server 'cvc.juturna.ca', :app, :web, :primary => true
set :deploy_to, "/opt/cvcbrowser1.0/production/"
set   :current_path, "/opt/cvcbrowser1.0/production/current"

after 'deploy:finalize_update', 'symfony:project:clear_controllers'