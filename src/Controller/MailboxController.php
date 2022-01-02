<?php

namespace App\Controller;

use App\Entity\Forwardings;
use App\Entity\Mailbox;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
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
        $data = json_decode($request->getContent());
        $username = property_exists($data, "username") ? $data->username : null;
        $password = property_exists($data, "password") ? $data->password : null;
        $name = property_exists($data, "name") ? $data->name : null;

        if(!$username || !$password || !$name) {
            return new JsonResponse(['success' => false, 'error' => 'Missing parameters'], 400);
        }

        if ($doctrine->getRepository(Mailbox::class)->findBy(['username' => $username]) == null) {
            $process = new Process(['/home/ubuntu/iRedMail-1.4.0/tools/create_user.sh', $username, $password]);
            $process->run();

            if ($process->isSuccessful()) {
                $domain = explode('@', $username)[1];
                $date = new DateTime();
                $mailbox = new Mailbox();
                $mailbox->setUsername($username);
                $mailbox->setPassword($process->getOutput());
                $mailbox->setName($name);
                $mailbox->setStoragebasedirectory('/var/vmail');
                $mailbox->setStoragenode('vmail1');
                $mailbox->setMaildir(self::generate_maildir($username, $date->format('Y.m.d.H.i.s')));
                $mailbox->setQuota(1024);
                $mailbox->setDomain($domain);
                $mailbox->setCreated($date);
                $mailbox->setPasswordlastchange($date);
                $mailbox->setLanguage('fr_FR');
                $doctrine->getManager()->persist($mailbox);
                $doctrine->getManager()->flush();
                $forwarding = new Forwardings();
                $forwarding->setAddress($username);
                $forwarding->setForwarding($username);
                $forwarding->setDomain($domain);
                $forwarding->setDestDomain($domain);
                $doctrine->getManager()->persist($forwarding);
                $doctrine->getManager()->flush();

                return new JsonResponse(['success' => true, 'message' => 'Mailbox created']);
            }

            return new JsonResponse(['success' => false, 'message' => 'Mailbox not created']);
        }

        return new JsonResponse(['success' => false, 'message' => 'Mailbox already exists']);
    }

    /**
     * @Route("/verify-mailbox", name="verifyMailbox", methods={"POST"})
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function verifyMailbox(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent());
        $username = property_exists($data, "username") ? $data->username : null;
        $password = property_exists($data, "password") ? $data->password : null;

        if(!$username || !$password) {
            return new JsonResponse(['success' => false, 'error' => 'Missing parameters'], 400);
        }

        $mailbox = $doctrine->getRepository(Mailbox::class)->findOneBy(['username' => $username]);
        if ( $mailbox != null && self::password_verification($password, $mailbox->getPassword())) {
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
        $data = json_decode($request->getContent());
        $username = property_exists($data, "username") ? $data->username : null;
        $password = property_exists($data, "password") ? $data->password : null;
        $name = property_exists($data, "name") ? $data->name : null;

        if(!$username || !$password || !$name) {
            return new JsonResponse(['success' => false, 'error' => 'Missing parameters'], 400);
        }

        $mailbox = $doctrine->getRepository(Mailbox::class)->findOneBy(['username' => $username]);
        if ( $mailbox != null && self::password_verification($password, $mailbox->getPassword())) {
            $mailbox->setName($name);
            $doctrine->getManager()->persist($mailbox);
            $doctrine->getManager()->flush();
            return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
    }

    public static function password_verification($password, $hash): bool
    {
        $process = new Process(['/bin/doveadm', 'pw', '-s', 'SSHA512', '-p', $password, '-t', $hash]);
        $process->run();

        return $process->isSuccessful();
    }

    public static function generate_maildir($username, $date): string
    {
        $str1 = substr($username, 0, 1);
        $str2 = substr($username, 1, 1);
        $str3 = substr($username, 2, 1);
        $domain = explode('@', $username)[1];
        if($str2 == null) {
            $str2 = $str1;
        }
        if($str3 == null) {
            $str3 = $str2;
        }
        return $domain . '/' . $str1 . '/' . $str2 . '/' . $str3 . '/' . $username . '-' . $date;
    }

}
