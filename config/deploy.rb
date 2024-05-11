########################
Setup project
########################
set :application, "Bs-Asistencias24"
set :repo_url, "https://github.com/LucianoPerez22/asistencias2024.git"
set :scm, :git#########################
Setup Capistrano
#########################
set :log_level, :info
set :use_sudo, false
set :ssh_options, {
  forward_agent: true
}
set :keep_releases, 3#######################################
Linked files and directories (symlinks)
#######################################
set :linked_files, ["config/packages/parameters.yaml"]
set :linked_dirs, [fetch(:log_path), fetch(:web_path) + "/uploads"] set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path)] set :composer_install_flags, '--no-interaction --optimize-autoloader'namespace :deploy do
  after :updated, 'composer:install_executable'
end

namespace :deploy do
  after :starting, 'composer:install_executable'
  after :updated, 'symfony:assets:install'
  after :updated, 'dependencies:yarn'
  after :updated, 'dependencies:upload'
end