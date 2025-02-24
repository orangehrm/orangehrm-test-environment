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
        $I->runShellCommand("docker inspect -f {{.State.Running}} test_web_rhel");
        $I->seeInShellOutput("true");
    }


    public function checkPHPVersion(UnitTester $I){
        $I->wantTo("verify php 8.2 is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel php --version");
        $I->seeInShellOutput('PHP 8.2');
    }

    public function checkPHPUnitVersion(UnitTester $I){
        $I->wantTo("verify phpunit 8 library is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel phpunit8 --version");
        $I->seeInShellOutput('PHPUnit 8.5.41');
    }

    public function checkPHPUnit3Version(UnitTester $I){
        $I->wantTo("verify phpunit 9 library is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel phpunit9 --version");
        $I->seeInShellOutput('PHPUnit 9.6.22');
    }

    public function checkPHPUnit7Version(UnitTester $I){
        $I->wantTo("verify phpunit 10 library is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel phpunit10 --version");
        $I->seeInShellOutput('PHPUnit 10.5.39');
    }

    public function checkPHPUnit8Version(UnitTester $I){
        $I->wantTo("verify phpunit 11 library is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel phpunit11 --version");
        $I->seeInShellOutput('PHPUnit 11.5.1');
    }

    public function checkNcCommand(UnitTester $I){
        $I->wantTo("verify nc command is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel nc -h");
        $I->seeInShellOutput('Ncat');

    }

    public function checkXdebugVersion(AcceptanceTester $I){
        $I->wantTo("verify xdebug is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel bash -c 'pecl list | grep xdebug'");
        $I->seeInShellOutput('xdebug     3.4.0 ');
    }

    public function checkGitVersion(AcceptanceTester $I){
        $I->wantTo("verify git is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel git --version");
        $I->seeInShellOutput('git');
    }


    public function checkNMAPIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify nmap is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel nmap -V");
        $I->seeInShellOutput('Nmap');
    }


    public function checkNodeIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify node is installed in the image");
        $I->runShellCommand('docker exec test_web_rhel bash -c "export PATH=$PATH:/root/.nvm/versions/node/v6.17.1/bin && node -v" ');
        $I->seeInShellOutput('v6');
    }


    public function checkSendMailIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify sendmail is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel which sendmail");
        $I->seeInShellOutput('/usr/sbin/sendmail');
    }

    public function checkSVNIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify SVN is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel svn --version");
        $I->seeInShellOutput('version 1');
    }

    public function checkBowerIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify bower is installed in the image");
        $I->runShellCommand('docker exec test_web_rhel bash -c "export PATH=$PATH:/root/.nvm/versions/node/v6.17.1/bin && bower --version" ');
        $I->seeInShellOutput('1.8');
    }

    public function checkGulpIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify Gulp is installed in the image");
        $I->runShellCommand('docker exec test_web_rhel bash -c "export PATH=$PATH:/root/.nvm/versions/node/v6.17.1/bin && gulp --version" ');
        $I->seeInShellOutput('version: 2');
    }

    public function checkASTIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify ast module is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel php -m | grep ast");
        $I->seeInShellOutput('ast');
    }

    public function checkVIMIsInstalled(AcceptanceTester $I){
        $I->wantTo("verify vim editor is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel vim --version");
        $I->seeInShellOutput('Vi IMproved');
    }

    //public function checkComposerIsInstalled(AcceptanceTester $I){
    //    $I->wantTo("verify composer is installed in the image");
    //    $I->runShellCommand("docker exec test_web_rhel composer --version");
    //    $I->seeInShellOutput('Composer version 1');
    //}

    public function checkComposer2IsInstalled(AcceptanceTester $I){
        $I->wantTo("verify composer is installed in the image");
        $I->runShellCommand("docker exec test_web_rhel /usr/local/bin/composer --version");
        $I->seeInShellOutput('Composer version 2');
    }

    public function checkOslonDBInstallation(UnitTester $I){
        $I->wantTo("verify Oslon DB is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel php -i | grep -i timezone");
        $I->seeInShellOutput('Timezone Database Version');
    }

    public function checkwkhtmltopdfInstallation(UnitTester $I){
        $I->wantTo("verify Oslon DB is installed in the container");
        $I->runShellCommand("docker exec test_web_rhel wkhtmltopdf --version");
        $I->seeInShellOutput('wkhtmltopdf 0.12');
    }

}
