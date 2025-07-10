<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Content;
use App\Entity\ContentRow;
use App\Entity\ContentRowPart;

#[AsCommand(
    name: 'demo:insert',
    description: 'Insert demo data',
)]
class InsertDemoDataCommand extends Command
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->createUsers();

        $this->createAboutMe();
        $this->createAboutThisSite();
        $this->createLeadershipExperience();

        // createBackendExperience()
        // createFrontendExperience()
        // createDevopsExperience()

        // createRestApiPage()
        //$this->createSsoPage();
        // createVersionControlPage()

        $this->em->flush();
        $io->success('Done.');
        return Command::SUCCESS;
    }

    protected function createBackendDevelopment(): static
    {

        $now = new \DateTimeImmutable('now');
        $content = new Content();
        $content->setSlug('backend-development');
        $content->setCategory('Development');
        $content->setTitle('Backend Development');
        $content->setShortDescription('My backend development experience.');
        $content->setSortOrder(3);
        $content->setCreatedAt($now);
        $content->setImageUrl('/images/placeholder.svg');
        $this->em->persist($content);

        $counter = 1;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Intro');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Intro Image');
        $contentRowPart->setImageUrl('/images/placeholder.svg');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Intro Paragraph');
        $contentHtml = '<p></p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        return $this;
    }

    protected function createLeadershipExperience(): static
    {
        $now = new \DateTimeImmutable('now');
        $content = new Content();
        $content->setSlug('leadership-experience');
        $content->setCategory('Management');
        $content->setTitle('Leadership Experience');
        $content->setShortDescription('I\'ve been leading projects for over 10 years.');
        $content->setSortOrder(3);
        $content->setCreatedAt($now);
        $content->setImageUrl('/images/architecture_diagram.png');
        $this->em->persist($content);

        // Intro , diagrams

        $counter = 1;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Intro');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Intro Image');
        $contentRowPart->setImageUrl('/images/architecture_diagram.png');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Intro Paragraph');
        $contentHtml = '<p>As time goes on, I find myself helping more with architecture, project planning, and project management. '.
            'I previously worked with LG Electronics as a Technical Lead, where I also helped with Software Architecture planning. '.
            'I\'ve really enjoyed creating diagrams in Lucid and Vizio, as well as translating diagrams into code. '.
            'In other projects, I\'ve had opportunities to create diagrams as part of our planning process, and it\'s always a fun process.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // Code review

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Code Review');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('About my Code Review Experience');
        $contentHtml = '<p>Code review is a critical step in the development process. '.
            'It\'s important to catch any potential issues before they reach the production server. '.
            'If the site slows down, it can reduce the number of paying customers visiting the site. '.
            'There are some common performance issues, which can create a bottleneck, and can cause the site to slow down. '.
            'One of the most common issues I\'ve seen is calling the database from the inside of a loop in the code. '.
            'In almost every instance, the query in the loop can be replaced with a single query. '.
            'It just takes a little more thought and time. It\'s always worth the extra effort.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Code Review Image');
        $contentRowPart->setImageUrl('/images/code_review.png');
        $this->em->persist($contentRowPart);

        // Project planning

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Project Planning');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Project Planning Image');
        $contentRowPart->setImageUrl('/images/project_estimation.gif');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('About my Project Planning Experience');
        $contentHtml = '<p>There are times when a project might seem huge and time-consuming, but it\'s actually straight-forward and quick. '.
            'The opposite can also be true. '.
            'In this scenario, it\'s important for project managers and developers to work together and plan the project with a realistic timeline. '.
            'There are usually some very interesting conversations to be had, and it\'s a great opportunity for everyone on the team to work together. '.
            'I always enjoy planning sessions. As a software developer, it\'s fun to bring some perspective to the table and have a group chat. </p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // Jira and Trello

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Jira and Trello');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('About my Jira and Trello Experience');
        $contentHtml = '<p>Jira is a powerful tool for project planning, and it has a lot of features for visualizations and analytics. '.
            'Whether it\'s time tracking, sprint planning, or creating simple tasks, it all adds up to important information which can be used to improve project performance. '.
            'I\'ve worked with most areas of Jira, and I enjoy working with it. I think a tightly managed project should use as many features as possible. </p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Jira Image');
        $contentRowPart->setImageUrl('/images/jira.png');
        $this->em->persist($contentRowPart);

        return $this;
    }

    protected function createAboutThisSite(): static
    {
        $now = new \DateTimeImmutable('now');
        $content = new Content();
        $content->setSlug('how-i-built-this-site');
        $content->setCategory('Full Stack');
        $content->setTitle('How I Built this Site');
        $content->setShortDescription('This site demonstrates my full stack development skills.');
        $content->setSortOrder(2);
        $content->setCreatedAt($now);
        $content->setImageUrl('/images/vuejs_symfony.png');
        $this->em->persist($content);

        // Intro

        $counter = 1;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Intro');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Intro Image');
        $contentRowPart->setImageUrl('/images/vuejs_symfony.png');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Intro Paragraph');
        $contentHtml = '<p>I built this site to highlight my full stack development skills. This site is actually two separate applications; a REST API server and a Vue frontend. '.
            'The API server is built with Symfony 7.x, and the frontend application is built with Vue 3.x. '.
            'The Vue frontend application pulls data from the REST API. The full source code is available on Github. </p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // Backend database

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Backend Database');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('About the Database');
        $contentHtml = '<p>The database contains three tables for storing content and one table for storing admin users. '.
            'The content table represents a single page on the site. '.
            'The content_row table represents individual rows of content within a page. '.
            'The content_row_part table represents a slot of content, and it can be stored as an image or a paragraph of text.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Database Image');
        $contentRowPart->setImageUrl('/images/database.png');
        $this->em->persist($contentRowPart);

        // Doctrine

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Doctrine database model');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Doctrine Image');
        $contentRowPart->setImageUrl('/images/doctrine_class.png');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('About the Doctrine database model');
        $contentHtml = '<p>Each database table has a class object in the application code. These classes are referred to as entities. '.
            'These entities utilize the Doctrine ORM, which is commonly used to manage database interaction in Symfony applications. '.
            'The Doctrine library contains an API for inserting, deleting, and updating rows in the database; using code instead of SQL.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // Backend REST API

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Backend REST API');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('About the Backend');
        $contentHtml = '<p>The backend REST API is built with Symfony 7.x. Its primary function is to return data to the frontend application. '.
            'The API has public endpoints as well as protected endpoints. '.
            'The protected endpoints are used for updating the database. It requires a Bearer token in the HTTP requests. '.
            'Each admin user is assigned a unique API key after they login successfully. '.
            'The frontend app includes the API key when it calls the backend API to update the database.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('REST API Image');
        $contentRowPart->setImageUrl('/images/rest_response.png');
        $this->em->persist($contentRowPart);

        // Vue JS frontend application

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Vue JS frontend application');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Vue JS Image');
        $contentRowPart->setImageUrl('/images/vuejs.jpg');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('About the Frontend');
        $contentHtml = '<p>The frontend is a stand-alone application built with Vue 3.x. '.
            'Its primary function is to pull data from the backend REST API and display it using templates. '.
            'The home page pulls a list of all content pages and displays a grid with links. You can see the raw data here. '.
            'When you click on a page in the grid, Vue switches the template and renders the rows of content slots which are associated with the page. '.
            'Each row can have one to three slots of content. '.
            'Click here to see the raw data for this page.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // Vue JS Login

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('How Login Works');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('How the frontend handles Login');
        $contentHtml = '<p>When you submit the login form, Vue sends your username and password to the login API. '.
            'If your login is successful, the API response will contain your user details and an API key. '.
            'The Vue code stores your user details in the web browser\'s local storage. '.
            'After the API key is stored in your browser, you can use the admin panel to call the protected API endpoints, and update content in the database.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Vue JS Image');
        $contentRowPart->setImageUrl('/images/local_storage.png');
        $this->em->persist($contentRowPart);

        // Frontend theme and Admin panel : tailwind css, shadcn/ui

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Frontend Theme');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Tailwind CSS Image');
        $contentRowPart->setImageUrl('/images/tailwindcss.png');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('About the Frontend Theme');
        $contentHtml = '<p>The frontend theme uses the Tailwind CSS package. '.
            'Tailwind simplifies the process of creating a professional looking site. '.
            'Using Tailwind, a developer can "plug and play" with all sorts of clean looking page components. '.
            'There are now packages available that are built on top of Tailwind and allow you to create a sidebar or login form with a few simple commands. '.
            'I built my admin panel using ShadCN. After a few commands, and a small amount of code, I had a working dashboard. </p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // Vue Form

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Vue Form');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('About Vue Form');
        $contentHtml = '<p>I decided to use VueForm for editing my site\'s content pages, since it supports editing nested layers of data within a single form. '.
            'VueForm is a powerful tool for creating complex forms. It provides a lot of options for adding logic around form inputs. '.
            'For example, when I choose text or image for my content slots I can have certain form inputs hide or display. '.
            'The code for this is easy to use, and it saves a lot of time.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Tailwind CSS Image');
        $contentRowPart->setImageUrl('/images/vueform.png');
        $this->em->persist($contentRowPart);

        $counter++;
        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder($counter);
        $contentRow->setTitle('Admin Panel Screenshots');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Vue Form Image');
        $contentRowPart->setImageUrl('/images/admin_edit_form.png');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Admin Panel Image');
        $contentRowPart->setImageUrl('/images/admin_panel.png');
        $this->em->persist($contentRowPart);

        return $this;
    }

    protected function createSsoPage(): static
    {
        $now = new \DateTimeImmutable('now');
        $content = new Content();
        $content->setSlug('sso');
        $content->setCategory('Backend');
        $content->setTitle('Single Sign On plugins');
        $content->setShortDescription('I\'ve developed many SSO plugins.');
        $content->setSortOrder(7);
        $content->setCreatedAt($now);
        $content->setImageUrl('/images/placeholder.svg');
        $this->em->persist($content);

        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder(1);
        $contentRow->setTitle('Intro');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Intro Image');
        $contentRowPart->setImageUrl('/images/placeholder.svg');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Intro Paragraph');
        $contentHtml = '<p>I\'ve developed many Single Sign On plugins. All of them are based on OAuth2 and SAML, which are industry standards. For B2B applications, it makes sense to use SAML. For public facing sites, it\'s more practical to use OAuth2. Most public facing sites will want the registration to be as simple as possible; while internal sites generally want to utilize their own company authentication. I always enjoy working with SSO plugins !</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        return $this;
    }

    protected function createAboutMe(): static
    {
        $now = new \DateTimeImmutable('now');
        $content = new Content();
        $content->setSlug('about-me');
        $content->setCategory('My Story');
        $content->setTitle('About Me');
        $content->setShortDescription('A little about me and my family.');
        $content->setSortOrder(1);
        $content->setCreatedAt($now);
        $content->setImageUrl('/images/family.png');
        $this->em->persist($content);

        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder(1);
        $contentRow->setTitle('Intro');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Intro Image');
        $contentRowPart->setImageUrl('/images/family.png');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Intro Paragraph');
        $contentHtml = '<p>Hi! I’m Jesse. Thank you for visiting! <br>I live in Fort Collins, Colorado with my wife and two kids. My wife, Lindsey is a digital marketer. We recently celebrated 10 years of marriage. Liam is in 2nd grade and Avelyn is in 4th grade.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder(2);
        $contentRow->setTitle('Mtn Biking');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Mtn Biking Text');
        $contentHtml = '<p>I really enjoy mountain biking !<br>My favorite trails are between Boulder and Lyons, Colorado. Exercise is important for the mind and body. Great scenery makes it so much more fun !</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Mtn Biking Image');
        $contentRowPart->setImageUrl('/images/mtnbike.jpg');
        $this->em->persist($contentRowPart);

        $contentRow = new ContentRow();
        $contentRow->setContent($content);
        $contentRow->setSortOrder(3);
        $contentRow->setTitle('Experience');
        $this->em->persist($contentRow);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('image');
        $contentRowPart->setSortOrder(1);
        $contentRowPart->setTitle('Experience Image');
        $contentRowPart->setImageUrl('/images/magento.png');
        $contentRowPart->setImageLinkUrl('https://www.credly.com/badges/60df67b9-2691-4db0-b18b-d07db6820c4d');
        $this->em->persist($contentRowPart);

        $contentRowPart = new ContentRowPart();
        $contentRowPart->setContentRow($contentRow);
        $contentRowPart->setTypeCode('text');
        $contentRowPart->setSortOrder(2);
        $contentRowPart->setTitle('Experience Text');
        $contentHtml = '<p>I\'ve been a software developer for over 10 years. Most of my experience is working with Adobe Commerce. '.
            'I also have experience working with Symfony, Vue, and Tailwind. I\'m comfortable working with large frameworks and architectures. '.
            'I always enjoy learning new things! Click the badge to see my Adobe Developer Certification.</p>';
        $contentRowPart->setContent($contentHtml);
        $this->em->persist($contentRowPart);

        // todo : images of Vue, Symfony, Laravel

        return $this;
    }

    protected function createUsers(): static
    {
        $user = new \App\Entity\User();
        $user->setEmail('test@fake.com');
        $user->setFirstName('Test');
        $user->setLastName('User');
        $user->setRoles(['ROLE_ADMIN']);

        $plaintextPassword = 'passw0rd';
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $this->em->persist($user);

        return $this;
    }
}
