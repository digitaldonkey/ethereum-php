#!Groovy
pipeline {
  agent {
    docker {
       image 'digitaldonkey/php-with-composer'
     }
  }
  stages {
    stage('PHP test') {
      steps {
          sh 'php --version'
      }
    }
    stage('install composer') {
      steps {
        sh 'composer install'
      }
    }
    stage('test phpunit') {
      steps {
        sh './vendor/bin/phpunit --version'
      }
    }
    stage('run phpunit') {
      steps {
        sh './vendor/bin/phpunit --log-junit results/phpunit/phpunit.xml --testsuite EthereumPhp'
      }
    }
  }
  post {
    always {
      junit 'results/**/*.xml'
    }
  }
}
