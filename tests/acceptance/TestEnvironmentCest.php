<?php


class TestEnvironmentCest
{
//    public function _before(AcceptanceTester $I)
//    {
//        $I->comment("Cloning project into /var/www/html");
//        $I->runShellCommand("docker exec test_web git clone https://github.com/ChanakaR/php-simple.git /var/www/html/php-simple");
//        $I->runShellCommand('docker exec uat_web chmod 777 -R /var/www/html');
//    }
//
//    public function _after(AcceptanceTester $I)
//    {
//        $I->comment("remove the project directory from /var/www/html");
//        $I->runShellCommand('docker exec uat_web rm -rf /var/www/html/php-simple');
//    }
//
//    public function checkSampleApp(AcceptanceTester $I){
//        $I->wantTo("verify uat environment is working properly with a php application");
//        $I->runShellCommand("docker exec uat_web php /var/www/html/php-simple/app.php");
//        $I->cantSeeInShellOutput("false");
//    }

    public function checkLoginToRabbitMQ(AcceptanceTester $I)
    {
        $I->wantTo("checking rabbitmq");
        $I->runShellCommand('sleep 10');
        $I->runShellCommand('docker exec rabbitmq_3.6_management bash -c "netstat -ltpn | grep 15671"');
        $I->seeInShellOutput('0.0.0.0:15671');
        $I->runShellCommand('docker exec rabbitmq_3.6_management bash -c "netstat -ltpn | grep 5671"');
        $I->seeInShellOutput(':::5671');
        $I->runShellCommand('docker exec rabbitmq_3.6_management bash -c "netstat -ltpn | grep 5672"');
        $I->seeInShellOutput(':::5672');
    }
}
