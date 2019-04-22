<?php


class WebContainerCest
{
    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    public function checkContainerIsRunning(UnitTester $I){
        $I->wantTo("verify ubuntu container up and running");
        $I->runShellCommand("docker inspect -f {{.State.Running}} test_web");
        $I->seeInShellOutput("true");
    }


    public function checkPHPVersion(UnitTester $I){
        $I->wantTo("verify php 5.6 is installed in the container");
        $I->runShellCommand("docker exec test_web php --version");
        $I->seeInShellOutput('PHP 5.6');
    }

    public function checkPHPUnitVersion(UnitTester $I){
        $I->wantTo("verify phpunit library is installed in the container");
        $I->runShellCommand("docker exec test_web phpunit --version");
        $I->seeInShellOutput('PHPUnit 5.7.21');
    }

    public function checkApacheServiceIsRunning(UnitTester $I){
        $I->wantTo("verify apache is up and running in the container");
        $I->runShellCommand("ping -c 10 localhost");
        $I->runShellCommand("docker exec test_web service httpd status");
        $I->seeInShellOutput('Active: active (running)');
    }

    public function checkXdebugStatus(UnitTester $I){
        $I->wantTo("verify Xdebug is installed in the container");
        $I->runShellCommand("docker exec test_web php -dzend_extension=xdebug.so --version");
        $I->seeInShellOutput('Xdebug v2.5.5');
    }

    public function npmTest(UnitTester $I){
        $I->wantTo("verify availability of npm");
        $I->runShellCommand("docker exec test_web npm -v");
        $I->seeInShellOutput("3.10.10");
    }

    public function nodeJSTest(UnitTester $I){
        $I->wantTo("verify availability of node js");
        $I->runShellCommand("docker exec test_web node -v");
        $I->seeInShellOutput("v6.13.1");
    }

}
