#######################
Setup Server
########################
server "pro.company.com", user: "sshuser", roles: %w{web}
set :deploy_to, "/path/to/your/deployment/directory"#########################
Capistrano Symfony
#########################
set :file_permissions_users, ['www-data']
set :webserver_user, "www-data"#########################
Setup Git
#########################
set :branch, "master"