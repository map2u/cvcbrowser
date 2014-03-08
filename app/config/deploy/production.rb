server '130.63.76.40', :app, :web, :primary => true
set :deploy_to, "/opt/cobasvirtual1.1/production/"
set   :current_path, "/opt/cobasvirtual1.1/production/current"

after 'deploy:finalize_update', 'symfony:project:clear_controllers'