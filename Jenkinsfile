pipeline {
    agent any

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install'
            }
        }

        stage('Tests Unitaires') {
            steps {
                sh './vendor/bin/phpunit --coverage-clover coverage.xml tests/'
            }
        }

        stage('Analyse SonarQube') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh 'sonar-scanner'
                }
            }
        }

        stage('Quality Gate') {
            steps {
                waitForQualityGate abortPipeline: true
            }
        }

        stage('Archiver Artefact') {
            steps {
                sh 'zip -r pipeline-cicd-${BUILD_NUMBER}.zip . -x "*.git*"'
                nexusArtifactUploader(
                    nexusVersion: 'nexus3',
                    protocol: 'http',
                    nexusUrl: 'nexus:8081',
                    groupId: 'com.monprojet',
                    version: "${BUILD_NUMBER}",
                    repository: 'mon-projet',
                    credentialsId: 'nexus-credentials',
                    artifacts: [[
                        artifactId: 'pipeline-cicd',
                        classifier: '',
                        file: "pipeline-cicd-${BUILD_NUMBER}.zip",
                        type: 'zip'
                    ]]
                )
            }
        }
    }

    post {
        success {
            echo 'Pipeline terminé avec succès'
        }
        failure {
            echo 'Pipeline échoué'
        }
    }
}
