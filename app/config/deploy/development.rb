server 'cvctest.juturna.ca', :app, :web, :primary => true
set :deploy_to, "/opt/cvctest.juturna.ca/production/"
set   :current_path, "/opt/cvctest.juturna.ca/production/current"

set :symfony_env_prod, "test"