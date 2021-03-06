<?php

namespace Scheb\TwoFactorBundle\Tests\Security\TwoFactor\IpWhitelist;

use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContext;
use Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextFactory;
use Scheb\TwoFactorBundle\Security\TwoFactor\IpWhitelist\DefaultIpWhitelistProvider;
use Scheb\TwoFactorBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DefaultIpWhitelistProviderTest extends TestCase
{
    /**
     * @var MockObject|Request
     */
    private $request;

    /**
     * @var MockObject|TokenInterface
     */
    private $token;

    /**
     * @var AuthenticationContextFactory
     */
    private $authenticationContextFactory;

    protected function setUp()
    {
        $this->request = $this->createMock(Request::class);
        $this->token = $this->createMock(TokenInterface::class);
        $this->authenticationContextFactory = new AuthenticationContextFactory(AuthenticationContext::class);
    }

    /**
     * @test
     */
    public function testGetWhitelistedIps_hasIpsConfigured_returnThoseIps(): void
    {
        $ipWhitelist = ['1.0.0.0', '2.0.0.0'];
        $context = $this->authenticationContextFactory->create($this->request, $this->token, 'firewallName');
        $provider = new DefaultIpWhitelistProvider($ipWhitelist);
        $this->assertEquals($ipWhitelist, $provider->getWhitelistedIps($context));
    }
}
