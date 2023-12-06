<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // the priority must be greater than the Security HTTP
            // ExceptionListener, to make sure it's called before
            // the default exception listener
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof AccessDeniedException) {
            return;
        }

        $content = "
        <html>
            <head>
                <title>403 Access Denied</title>
                <style>

                    html {
                        background-size: cover;
                        background-image: url('https://www.app.blacksheep-van.com/img/bgapp.jpg');
                        background-repeat: no-repeat;
                        font-family: 'Montserrat', sans-serif;
                        color: #fff;

                    }
                    h1{
                        margin-top:0px
                    }
                    .alert{
                        background-color: rgba(255, 0, 0, 0.51);

                        padding: 50px;
                        border-radius: 10px;
                        max-width: 500px;
                        margin: auto;
                    }
                    .btnRetour{
                        background-color: #fff;
                        color: #000;
                        padding: 10px 20px;
                        border-radius: 10px;
                        text-decoration: none;
                        font-weight: bold;
                        font-size: 20px;
                        margin-top: 50px;

                    }
                    </style>
            </head>
            <body style='text-align:center;margin-top:50px'>

                <img src='https://www.app.blacksheep-van.com/img/logo_bs_black.png' style='width:200px;margin-bottom:150px'/>
                  <div class='alert'>
                    <h1>403 Access Denied</h1>
                <p>Ce contenu ne t'est pas destiné</p>
                <a class='btnRetour' href='/'>Retour à l'accueil</a>
            </div>
            </body>
        </html>

        ";

        $event->setResponse(new Response($content, 403));

    }
}
