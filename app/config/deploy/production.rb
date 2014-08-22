server 'cvc.juturna.ca', :app, :web, :primary => true
set :deploy_to, "/media/web_documents/cvcbrowser1.0/production/"
set   :current_path, "/media/web_documents/cvcbrowser1.0/production/current"

after 'deploy:finalize_update', 'symfony:project:clear_controllers'