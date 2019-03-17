<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class WebUserContext extends RawMinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I am not logged in
     */
    public function iAmNotLoggedIn()
    {
        $logoutLink = $this->getSession()
            ->getPage()
            ->hasLink('Logout');

        Assert::assertFalse($logoutLink,'The link "Logout" is in the page.');
    }


}
