set :stage_dir, 'app/config/deploy' # needed for Symfony2 only
require 'capistrano/ext/multistage'
set :stages, %w(production testing development)

set :application, "CVCBrowser"
set :user, "jzhao"

default_run_options[:pty] = true

set :webserver_user,    "www-data"
set :permission_method, :acl
set :group, "jzhao"
set :use_set_permissions, false

set :repository,  "https://github.com/josephzhao/cvcbrowser.git"
#set :scm,         :git
set :deploy_via,    :remote_cache

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/../Data" ,app_path + "/cache",app_path + "/logs", web_path + "/uploads"]
set :writable_dirs,     [app_path + "/cache", app_path + "/logs", web_path + "/uploads"]
set :branch, "master"
set :model_manager, "doctrine"
set   :group_writable, true

default_run_options[:pty] = true 
ssh_options[:forward_agent] = true

set :use_composer, true
set :update_vendors, true
#set :copy_vendors, true
set :composer_options,  "--ansi --no-interaction install --no-dev"

set :use_sudo,      false
set :keep_releases,  5

logger.level = Logger::MAX_LEVEL



#after "deploy:setup", :setup_ownership
after "deploy:finalize_update", :setup_ownership
before "deploy:update_code", :setup_ownership

task :setup_ownership do
      
#     run "#{sudo} chown -R #{user}:#{group} #{deploy_to} && chmod -R g+s #{deploy_to}"
#     run "#{sudo} chmod -R 777 #{deploy_to} #{current_path}/app/cache #{current_path}/app/logs"
end

after "deploy:update_code" do
  capifony_pretty_print "--> Ensuring cache directory permissions"
#  run "setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX #{latest_release}/#{cache_path}"
#  run "setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX #{latest_release}/#{cache_path}"
  capifony_puts_ok
end


namespace :deploy do
     task :update_code, :except => { :no_release => true } do
         on_rollback { my_namespace.rollback }
        strategy.deploy!
        finalize_update
     end
 end

namespace :my_namespace do

  task :rollback, :except => { :no_release => true } do
        #run 'rm-rf #{release_path}; true' 
        #default capistrano action on rollback

        #my custom actions
    #    run "cd "+shared_path+"/../current"
    #    run "php composer.phar dump-autoload"

        set :release_path, shared_path+"/../current"
     #   run "rm -rf #{latest_release}/app/cache/*"
     #   symfony.composer.dump_autoload
  end
 end