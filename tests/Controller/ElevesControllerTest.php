<?php

namespace App\Tests\Controller;

use App\Entity\Eleves;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ElevesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/eleves/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Eleves::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'elefe[nomEleve]' => 'Testing',
            'elefe[prenomEleve]' => 'Testing',
            'elefe[dateNaissance]' => 'Testing',
            'elefe[classeEleve]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setNomEleve('My Title');
        $fixture->setPrenomEleve('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setClasseEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setNomEleve('Value');
        $fixture->setPrenomEleve('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setClasseEleve('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'elefe[nomEleve]' => 'Something New',
            'elefe[prenomEleve]' => 'Something New',
            'elefe[dateNaissance]' => 'Something New',
            'elefe[classeEleve]' => 'Something New',
        ]);

        self::assertResponseRedirects('/eleves/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomEleve());
        self::assertSame('Something New', $fixture[0]->getPrenomEleve());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getClasseEleve());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setNomEleve('Value');
        $fixture->setPrenomEleve('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setClasseEleve('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/eleves/');
        self::assertSame(0, $this->repository->count([]));
    }
}
