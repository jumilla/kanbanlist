<h2>Forgot your password?</h2>

{{ form_for(resource, :as => resource_name, :url => password_path(resource_name), :html => { :method => :post }) do |f| }}
  {{ devise_error_messages! }}

  <p>{{ f.label :email }}<br />
  {{ f.email_field :email }}</p>

  <p>{{ f.submit "Send me reset password instructions" }}</p>
@end

{{ render :partial => "devise/shared/links" }}