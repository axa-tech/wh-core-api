<?php

namespace Axa\Bundle\WhapiBundle\Tests\Platform;


use Axa\Bundle\WhapiBundle\Platform\PlatformService;

class PlatformServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Axa\Bundle\WhapiBundle\Platform\PlatformService
     */
    protected $service;

    /**
     *
     * @var \Axa\Bundle\WhapiBundle\Entity\UserRepository
     */
    protected $userRepository;

    /**
     *
     * @var \Axa\Bundle\WhapiBundle\Entity\PlatformRepository
     */
    protected $platformRepository;

    /**
     *
     * @var \Axa\Bundle\WhapiBundle\Entity\OfferRepository
     */
    protected $offerRepository;


    public function setUp()
    {
        $this->userRepository = $this
            ->getMockBuilder('\Axa\Bundle\WhapiBundle\Entity\UserRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->platformRepository = $this
            ->getMockBuilder('\Axa\Bundle\WhapiBundle\Entity\PlatformRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->offerRepository = $this
            ->getMockBuilder('\Axa\Bundle\WhapiBundle\Entity\OfferRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new PlatformService( $this->userRepository, $this->platformRepository, $this->offerRepository);
    }

    public function testFake()
    {
        $this->assertTrue(true);
    }
}