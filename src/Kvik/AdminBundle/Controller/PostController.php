<?php

namespace Kvik\AdminBundle\Controller;

use Kvik\AdminBundle\Entity\Post;
use Kvik\AdminBundle\Entity\Term;
use Kvik\AdminBundle\Form\PostType;
use Kvik\AdminBundle\Repository\PostRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    private $type;
    private $params;
    /**
     * @param Request $request
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $type){
        $em = $this->getDoctrine()->getManager();
        $params = [
            'status' => $request->query->get('status'),
            'cat' => $request->query->get('cat'),
            'tag' => $request->query->get('tag'),
            'author' => $request->query->get('author'),
            'pge' => $request->query->get('pge')
        ];

        $this->params = $params;
        $this->type = $type;
        $form = $this->createFormBuilder()
            ->add('post', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'id',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function(PostRepository $pr){
                    return $pr->getPosts($this->params, $this->type);
                },
                'label' => false
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Publier' => 'publish',
                    'Mettre en brouillon' => 'draft',
                    'Déplacer vers la corbeille' => 'trash'
                ]
            ])
            ->add('valider', SubmitType::class)
            ->getForm()
        ;
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid() ){
            $data = $form->getData();
            if( !empty($data['post']) ){
                foreach($data['post'] as $post){
                    $post->setPostStatus($data['status']);
                    $em->persist($post);
                }
                $em->flush();
            }
            return $this->redirectToRoute('kvik_admin_post', ['type' => $type]);
        }
        return $this->render('@KvikAdmin/Post/index.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
            'total' => (int) $em->getRepository(Post::class)->getTotalPosts($params, $type)
        ]);
    }

    public function addAction(Request $request, $type)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post, ['type' => $type]);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug( $this->container->get('kvik.sanitize')->slugify($post->getSlug(), $post->getTitle(), $post) );
            $post->setPostType($type);
            $post->setEditor($this->getUser());
            $post->setPostType($type);
            if($post->getPostType() == 'post'){
                $this->container->get('kvik.postManager')->addPostTags($post, $form["newTag"]->getData());
                if($post->getTerms()->isEmpty()) $this->container->get('kvik.postManager')->addToUncategorized($post);
            }
            if($post->getPostType() === 'page') $this->container->get('kvik.postManager')->removeParentInChildren($post);

            $em->persist($post);

            $em->flush();
            return $this->redirectToRoute('kvik_admin_post_edit', [
                'id' => $post->getId(),
                'type' => $post->getPostType()
            ]);
        }
        return $this->render('@KvikAdmin/Post/add.html.twig', [
            'type' => $type,
            'form' => $form->createView(),
            'tags' => $em->getRepository(Term::class)->findBy(['termType' => 2])
        ]);
    }

    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $post, [
            'todo' => 'edit',
            'type' => $post->getPostType()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ){
            $post->setSlug( $this->container->get('kvik.sanitize')->slugify($post->getSlug(), $post->getTitle(), $post) );
            $post->setEditor($this->getUser());
            if($post->getPostType() === 'post'){
                $this->container->get('kvik.postManager')->addPostTags($post, $form["newTag"]->getData());
                if( !$this->container->get('kvik.postManager')->hasCats($post) ) $this->container->get('kvik.postManager')->addToUncategorized($post);
            }
            if($post->getPostType() === 'page') $this->container->get('kvik.postManager')->removeParentInChildren($post);

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('kvik_admin_post_edit', [
                'id' => $post->getId(),
                'type' => $post->getPostType()
            ]);
        }
        return $this->render('@KvikAdmin/Post/add.html.twig', [
            'type' => $post->getPostType(),
            'form' => $form->createView(),
            'post' => $post,
            'tags' => $em->getRepository(Term::class)->findBy(['termType' => 2])
        ]);
    }

    public function trashAction($id, $action){
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);
        if ( $post === null ) return $this->redirectToRoute('kvik_admin_index');
        else{
            $post->setPostStatus($action);
            if($post->getPostType() === 'page'){
                if( $action === 'trash' ) $this->container->get('kvik.postManager')->removeTrashedParent($post);
            }
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('kvik_admin_post', [
                'type' => $post->getPostType()
            ]);
        }
    }
    
    public function allAction(Request $request, $type){
        $term = $request->query->get('term');
        if( !empty($term) ){
            $titles = $this->container->get('kvik.postManager')->getTermAutocompletion($type, $term);
            $array = [];
            for($i=0; $i<= count($titles)-1; $i++){
                $array[$i]['label'] = $titles[$i]->getTitle();
                $array[$i]['value'] = $titles[$i]->getSlug();
            }
            return new JsonResponse($array);
        }
        else return new JsonResponse([]);
    }
}
