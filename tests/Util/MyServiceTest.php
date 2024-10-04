<?php

namespace App\Tests\Util;

use App\Util\MyService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MyServiceTest extends KernelTestCase
{
    private MyService $myService;
    protected function setUp(): void{
        self::bootKernel();
        $this->myService = static::getContainer()->get(MyService::class);
    }
    public function testReduceDataWithLength(): void
    {
        /*$kernel = self::bootKernel();
        $myService = static::getContainer()->get(MyService::class);*/
        //On teste avec une longueur précise
        $content="Texte de 22 caractères";
        $this->assertSame('Texte d...', $this->myService->reduce($content,10));
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }

    public function testReduceDataWithoutLength(): void
    {
       /* $kernel = self::bootKernel();
        $myService = static::getContainer()->get(MyService::class);*/

        //On teste avec une longueur précise
        $content="Texte de 22 caractères";
        $this->assertSame('Texte d...', $this->myService->reduce($content));
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    }
}
