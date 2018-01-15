<?php
/**
 * Created by PhpStorm.
 * User: yelloflash
 * Date: 1/15/18
 * Time: 3:58 PM
 */

class NodejsDependancyCest
{

    public function _before(UnitTester $I)
    {
    }

    public function _after(UnitTester $I)
    {
    }

    public function npmTest(UnitTester $I){
        $I->wantTo("verify availability of npm");
        $I->runShellCommand("docker exec test_web npm -v");
        $I->seeInShellOutput("3.10.10");
    }

    public function nodeJSTest(UnitTester $I){
        $I->wantTo("verify availability of node js");
        $I->runShellCommand("docker exec test_web node -v");
        $I->seeInShellOutput("v6.12.2");
    }

}