<h2>Change your password</h2>

{{ form_for(resource, :as => resource_name, :url => password_path(resource_name), :html => { :method => :put }) do |f| }}
  {{ devise_error_messages! }}
  {{ f.hidden_field :reset_password_token }}

  <p>{{ f.label :password, "New password" }}<br />
  {{ f.password_field :password }}</p>

  <p>{{ f.label :password_confirmation, "Confirm new password" }}<br />
  {{ f.password_field :password_confirmation }}</p>

  <p>{{ f.submit "Change my password" }}</p>
@end

{{ render :partial => "devise/shared/links" }}