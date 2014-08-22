server '130.63.76.40', :app, :web, :primary => true
set :deploy_to, "/media/web_documents/cvcbrowser1.0/development/"
set   :current_path, "/media/web_documents/cvcbrowser1.0/development/current"

set :symfony_env_prod, "test"