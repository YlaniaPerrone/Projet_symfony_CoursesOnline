<?php

namespace App\Security;

use App\Repository\TrainerRepository;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class CustomAuthentication extends AbstractLoginFormAuthenticator
{
    private const LOGIN_ROUTE = 'app_trainer_login';
    private const ACCESS_MANAGER = 'ROLE_MANAGER';
    private const ACCESS_TRAINER = 'ROLE_TRAINER';
    private TrainerRepository $trainerRepository;
    private RouterInterface $router;
    use TargetPathTrait;

    public function __construct(TrainerRepository $trainerRepository, RouterInterface $router, UrlGeneratorInterface $urlGenerator)
    {
        $this->trainerRepository = $trainerRepository;
        $this->router = $router;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): bool
    {
//        dd($request->get('_route') === CustomAuthentication::LOGIN_ROUTE);
//        dd($this->getLoginUrl($request) === $request->getPathInfogetPathInfo());
        return ($this->getLoginUrl($request) === $request->getPathInfo() && $request->isMethod('POST'));
//        return ($request->get('_route') === CustomAuthentication::LOGIN_ROUTE && $request->isMethod('POST'));
//        test if we are on the right route & if the user is logged  (no return logging form, go to authenticate)

    }


    public function authenticate(Request $request): Passport
    {
//        dd($request);
        $password = $request->request->get('_password', '');
        $email = $request->request->get('_username', '');
        $csrfToken = $request->request->get('_csrf_token');

        $request->getSession()->set(Security::LAST_USERNAME, $email);
//        dd(        $request->getSession()->set(Security::LAST_USERNAME, $email));

//      $userIdentifier -> recupere plus rapidement les infos de l'utilisateur
        return new Passport(
            new UserBadge($email, function ($userIdentifier) {
                // optionally pass a callback to load the User manually
                $trainer = $this->trainerRepository->findTrainerByCompany($userIdentifier);
                if (!$trainer) {
                    throw new UserNotFoundException();

                }
                return $trainer;
            }),

            new PasswordCredentials($password),
            [new CsrfTokenBadge('authenticate', $csrfToken)]
        );


    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): RedirectResponse
    {

//        dd('onAuthenticationSuccess');
//        dd([
//            'request'  => $request,
//            'token'    => $token,
//            'role'     => $token->getRoleNames() === ['ROLE_MANAGER'],
//            'firewall' => $firewallName,
//            'session'  => $request->hasSession(),
//
//        ]);
//        dd(        $request->getSession());

        $request->getSession();
        $token->getUser()->eraseCredentials();
        $request->getSession();
        if (in_array(CustomAuthentication::ACCESS_MANAGER, $token->getRoleNames()) ) {

            return new RedirectResponse($this->router->generate('app_manager_dashboard'));

//            dd('role manager',   $request->hasSession());
        }

        return new RedirectResponse($this->router->generate('app_courses'));

    }

    protected function getLoginUrl(Request $request): string
    {
//        dd('getLoginUrl');

        return $this->router->generate(CustomAuthentication::LOGIN_ROUTE);
    }

//    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
//    {
//
//        dd('failure');
//            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
//            return new RedirectResponse(
//            $this->router->generate('app_login')
//            );
//    }

    public function start(Request $request, AuthenticationException $authException = null) : Response
    {
        dd(  $this);
       return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }



}