<?php

function is_sample_user()
{
	return Auth::user()->email == "sample@kanban.list";
}
