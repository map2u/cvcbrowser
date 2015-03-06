server 'cvc.juturna.ca', :app, :web, :primary => true
set :deploy_to, "/opt/cvc.juturna.ca/cvcbrowser1.0/development/"
set   :current_path, "/media/web_documents/cvcbrowser1.0/development/current"

set :symfony_env_prod, "test"