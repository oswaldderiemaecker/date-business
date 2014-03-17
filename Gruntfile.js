module.exports = function(grunt) {
    grunt.initConfig({
        phplint: {
            all: ['src/**/*.php', 'tests/**/*.php']
        },
        phpunit: {
            fast: {
                dir: 'tests',
                options: {
                    bin: 'vendor/bin/phpunit',
                    noConfiguration: true,
                    bootstrap: 'vendor/autoload.php',
                    colors: true,
                    strict: true
                }
            },
            coverage: {
                dir: 'tests',
                options: {
                    bin: 'vendor/bin/phpunit',
                    noConfiguration: true,
                    bootstrap: 'vendor/autoload.php',
                    coverage: true,
                    colors: true,
                    strict: true
                }
            },
            full: {
                classes: {
                    dir: 'tests/'
                },
                options: {
                    bin: 'vendor/bin/phpunit',
                    bootstrap: 'vendor/autoload.php',
                    colors: true,
                    strict: true
                }
            }
        },
        phpcs: {
            application: {
                dir: ['src', 'tests']
            },
            options: {
                bin: 'vendor/bin/phpcs',
                standard: 'PSR1'
            }
        },
        phpmd: {
            application: {
                dir: ['src']
            },
            options: {
                bin: 'vendor/bin/phpmd',
                rulesets: 'codesize,naming,unusedcode'
            }
        },
        watch: {
            test: {
                files: ['src/**/*.php', 'tests/**/*Test.php'],
                tasks: ['phpunit:fast']
            }
        },
        githooks: {
            all: {
                'pre-commit': 'phplint phpunit:fast'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-githooks');
    grunt.loadNpmTasks('grunt-phplint');
    grunt.loadNpmTasks('grunt-phpunit');
    grunt.loadNpmTasks('grunt-phpcs');
    grunt.loadNpmTasks('grunt-phpmd');
};