<?php

namespace App\Controller;

use App\Crypto\SubstitutionCipherCracker;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DecipherType;
use App\Crypto\CipherCrackerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Michael Phillips <michaeljoelphillips@gmail.com>
 */
class CryptoController
{
    /** @var CipherCrackerInterface */
    protected $cipherCracker;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var \Twig_Environment */
    protected $twig;

    /**
     * @param CipherCrackerInterface $cipherCracker
     * @param FormFactoryInterface $formFactory
     * @param \Twig_Environment $twig
     */
    public function __construct(
        CipherCrackerInterface $cipherCracker,
        FormFactoryInterface $formFactory,
        \Twig_Environment $twig
    ) {
        $this->cipherCracker = $cipherCracker;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * The main route for the application.
     */
    public function indexAction()
    {
        $form = $this->getForm();

        return $this->twig->render('app/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function decipherAction(Request $request)
    {
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $cipherText = $form->getData()['cipherText'];

            $cipher = $this->cipherCracker->crack($cipherText);

            return new JsonResponse([
                'plain_text' => $cipher->decipher($cipherText)
            ]);
        }
    }

    /**
     * A helper method for creating the form.
     *
     * @return DecipherType
     */
    private function getForm() : FormInterface
    {
        return $this->formFactory->create(DecipherType::class, null, [
            'action' => '/decipher'
        ]);
    }
}
