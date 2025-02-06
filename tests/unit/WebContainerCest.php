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
        $I->wantTo("verify centos container up and running");
        $I->runShellCommand("docker inspect -f {{.State.Running}} test_web_ubuntu");
        $I->seeInShellOutput("true");
    }


    public function checkPHPVersion(UnitTester $I){
        $I->wantTo("verify php 8.3 is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu php --version");
        $I->seeInShellOutput('PHP 8.3');
    }

    public function checkPHPUnit8Version(UnitTester $I){
        $I->wantTo("verify phpunit 8 library is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu phpunit8 --version");
        $I->seeInShellOutput('PHPUnit 8.5.41');
    }

    public function checkPHPUnit9Version(UnitTester $I){
        $I->wantTo("verify phpunit 9 library is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu phpunit9 --version");
        $I->seeInShellOutput('PHPUnit 9.6.22');
    }

    public function checkPHPUnit10Version(UnitTester $I){
        $I->wantTo("verify phpunit 10 library is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu phpunit10 --version");
        $I->seeInShellOutput('PHPUnit 10.5.39');
    }

    public function checkPHPUnit11Version(UnitTester $I){
        $I->wantTo("verify phpunit 11 library is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu phpunit11 --version");
        $I->seeInShellOutput('PHPUnit 11.5.1');
    }

    public function checkNcCommand(UnitTester $I){
        $I->wantTo("verify nc command is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu bash -c 'apt list --installed | grep netcat'");
        $I->seeInShellOutput('netcat');

    }

    public function checkGitVersion(AcceptanceTester $I){
        $I->wantTo("verify git is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu git --version");
        $I->seeInShellOutput('git version 2.43.0');
    }


    public function checkNMAPIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify nmap is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu nmap -V");
        $I->seeInShellOutput('version 7.94');
    }


    public function checkNodeIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify node is installed in the image");
        $I->runShellCommand('docker exec test_web_ubuntu bash -c \'export NVM_DIR="/root/.nvm"; [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh";node -v;\'');
        $I->seeInShellOutput('v6.17.1');
    }


    public function checkSendMailIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify sendmail is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu which sendmail");
        $I->seeInShellOutput('/usr/sbin/sendmail');
    }

    public function checkSVNIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify SVN is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu svn --version");
        $I->seeInShellOutput('version 1');
    }

    public function checkBowerIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify bower is installed in the image");
        $I->runShellCommand('docker exec test_web_ubuntu bash -c \'export NVM_DIR="/root/.nvm"; [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh";bower --version;\'');
        $I->seeInShellOutput('1.8');
    }

    public function checkGulpIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify Gulp is installed in the image");
        $I->runShellCommand('docker exec test_web_ubuntu bash -c \'export NVM_DIR="/root/.nvm"; [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh";gulp --version;\'');
        $I->seeInShellOutput('version: 2');
    }

    public function checkASTIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify ast module is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu php -m | grep ast");
        $I->seeInShellOutput('ast');
    }

    public function checkVIMIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify vim editor is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu vim --version");
        $I->seeInShellOutput('Vi IMproved 9.1');
    }

    public function checkComposerIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify composer is installed in the image");
        $I->runShellCommand("docker exec test_web_ubuntu composer --version");
        $I->seeInShellOutput('Composer version 2');
    }

    public function checkOslonDBInstallation(UnitTester $I){
        $I->wantTo("verify Oslon DB is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu php -i | grep -i timezone");
        $I->seeInShellOutput('Timezone Database Version');
    }

    public function checkwkhtmltopdfInstallation(UnitTester $I){
        $I->wantTo("verify wkhtmltopdf is installed in the container");
        $I->runShellCommand("docker exec test_web_ubuntu wkhtmltopdf --version");
        $I->seeInShellOutput('wkhtmltopdf 0.12');
    }

}
