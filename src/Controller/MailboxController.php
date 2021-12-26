<?php

namespace App\Controller;

use App\Entity\Mailbox;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

class MailboxController extends AbstractController
{

    /**
     * @Route("/create-mailbox", name="createMailbox", methods={"POST"})
     */
    public function createMailbox(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $password = $data['password'];
        $name = $data['name'];

        if ($doctrine->getRepository(Mailbox::class)->findBy(['username' => $username]) != null) {
            $process = new Process(['bash', '/home/ubuntu/iRedMail-1.4.0/tools/create_mail_user_SQL.sh', $username, $password]);
            $process->run();

            if ($process->isSuccessful()) {
                $mailbox = $doctrine->getRepository(Mailbox::class)->findBy(['username' => $username]);
                $mailbox->setName($name);
                $doctrine->getManager()->flush();
            }

            return new JsonResponse(['success' => $process->isSuccessful()]);
        }

        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/verify-mailbox", name="verifyMailbox", methods={"POST"})
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function verifyMailbox(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $password = $data['password'];
        $mailbox = $doctrine->getRepository(Mailbox::class)->findOneBy(['username' => $username]);
        if ( $mailbox != null && PasswordVerificationController::password_verification($password, $mailbox->getPassword())) {
                return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/modify-mailbox", name="modifyMailbox", methods={"POST"})
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function modifyMailbox(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'];
        $password = $data['password'];
        $name = $data['name'];
        $mailbox = $doctrine->getRepository(Mailbox::class)->findOneBy(['username' => $username]);
        if ( $mailbox != null && PasswordVerificationController::password_verification($password, $mailbox->getPassword())) {
            $mailbox->setName($name);
            $doctrine->getManager()->flush();
            return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
    }

}
