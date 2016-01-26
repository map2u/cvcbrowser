server 'cvctest.juturna.ca', :app, :web, :primary => true
set :deploy_to, "/opt/cvc2.juturna.ca/production/"
set   :current_path, "/opt/cvc2.juturna.ca/production/current"

after 'deploy:finalize_update', 'symfony:project:clear_controllers'