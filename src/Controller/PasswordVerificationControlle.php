<?php

class PasswordVerificationController
{

    /**
     * @Route("/password-verification", name="password_verification", methods={"POST"})
     */
    public function passwordVerification(Request $request) {
        $data = json_decode($request->getContent(), true);
        $password = $data['password'];
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $data['userId']]);
        if (password_verification($password, $user->getPassword())) {
            return new JsonResponse(['success' => true]);
        } else {
            return new JsonResponse(['success' => false]);
        }
    }

}
