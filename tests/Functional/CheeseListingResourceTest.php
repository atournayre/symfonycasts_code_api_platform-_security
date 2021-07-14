<?php


namespace App\Tests\Functional;

use App\ApiPlatform\Test\ApiTestCase;
use App\Entity\User;

class CheeseListingResourceTest extends ApiTestCase
{
    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request('POST', '/api/cheeses', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [],
        ]);

        $this->assertResponseStatusCodeSame(401);

        $user = new User();
        $user->setEmail('cheese_tester@example.com');
        $user->setUsername('cheese_tester');
        $user->setPassword('$argon2id$v=19$m=65536,t=6,p=1$HfozEktpWfdQmoXZz9sCYA$72/pDN2ZA1591NsBDdRMuUbziZVKzwx+/zaCywyKmNQ');

        $em = self::$container->get('doctrine')->getManager();

        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'cheese_tester@example.com',
                'password' => 'foo',
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);

    }
}