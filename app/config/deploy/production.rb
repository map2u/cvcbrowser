server 'cvc.juturna.ca', :app, :web, :primary => true
set :deploy_to, "/opt/cvc.juturna.ca/production/"
set   :current_path, "/opt/cvc.juturna.ca/production/current"

after 'deploy:finalize_update', 'symfony:project:clear_controllers'