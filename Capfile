require 'capistrano/setup'
require 'capistrano/deploy'
require 'capistrano/symfony'

set :application, 'asistencias2024'
set :repo_url, 'git@github.com:user/my_symfony_app.git'

set :symfony_env, 'prod'
set :symfony_var_dir, 'shared/var'
set :symfony_log_dir, 'shared/log'
set :symfony_web_dir, 'public'

set :deploy_to, '/var/www/my_symfony_app'

set :keep_releases, 5

namespace :deploy do
  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      execute :sudo, :service, :nginx, :restart
    end
  end
end