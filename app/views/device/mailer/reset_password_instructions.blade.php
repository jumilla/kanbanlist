<p>Hello {{ @resource.email }}!</p>

<p>Someone has requested a link to change your password, and you can do this through the link below.</p>

<p>{{ link_to 'Change my password', edit_password_url(@resource, :reset_password_token => @resource.reset_password_token) }}</p>

<p>If you didn't request this, please ignore this email.</p>
<p>Your password won't change until you access the link above and create a new one.</p>
