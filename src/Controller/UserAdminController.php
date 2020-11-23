<?php

namespace App\Controller;

use App\Entity\GiftsList;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use App\Service\Emails\PHPMailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserAdminController extends AbstractController
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * UserAdminController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/admin", name="app_user_admin")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param PHPMailerService $mailerService
     * @return Response
     */
    public function index(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        PHPMailerService $mailerService
    ): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER'])
            ->setIsSelected(false)
            ->setIsAllowedToSelectUser(0)
            ->setIsFirstConnection(1);

        $form = $this->createForm(UserFormType::class, $user, [
            'action' => $this->generateUrl('app_user_admin'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $password = $form->get('password')->getData();
            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();

            $giftList = new GiftsList();
            $giftList->setIsPublished(0);
            $entityManager->persist($giftList);

            $user->setFirstname($firstname)
                ->setLastname($lastname)
                ->setUsername(lcfirst($firstname) . "." . lcfirst($lastname))
                ->setPassword($encoder->encodePassword($user, $password))
                ->setImage('/build/images/user/' . $form->get('image')->getData())
                ->setHash(md5($firstname . "." . $lastname))
                ->setEmail($form->get('email')->getData())
                ->setGiftsList($giftList);
            $entityManager->persist($user);
            $entityManager->flush();

            $mailerService->send(
                [[$user->getEmail(), $user->getFirstName() . " " . $user->getLastname()]],
                'Dein Konto ist erstellt!',
                $this->renderView("user_admin/email_user.html.twig", [
                    'user' => $user,
                    'password' => $password
                ])
            );

            $this->addFlash('success', 'Benutzer erfolgreich erstellt!');

            return $this->redirectToRoute("app_user_admin");
        }

        $users = $this->userRepository->findAll();

        return $this->render('user_admin/index.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }
}
