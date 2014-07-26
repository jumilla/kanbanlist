<?php

class BooksController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function create()
	{
		Log::debug(__METHOD__);

		$bookName = Input::get('book_name');
		$filter = Input::get('filter');

		$book = Book::whereUserId(Auth::user()->id)->whereName($bookName)->first();
		if (is_null($book)) {
			$book = Book::create([
				'user_id' => Auth::user()->id,
				'name' => $bookName,
			]);
		}
		Session::put('book_id', $book->id);

		return $this->renderCurrentBook($filter);
	}

	public function show($id)
	{
		Log::debug(__METHOD__);

		$filter = Input::get('filter');

		Session::put('book_id', $id);

		return $this->renderCurrentBook($filter);
	}

	public function destroy($id)
	{
		Log::debug(__METHOD__);

		$filter = Input::get('filter');

		// TODO

		return $this->renderCurrentBook($filter);
	}

	private function renderCurrentBook($filter = '')
	{
		return $this->renderJsonForUpdateBookJson($filter, 15);
	}	
}

/*
  def create
	@user_name = current_user.name

	new_book_name = params[:book_name]
	filter_str = params[:filter]

	aready_book = Book.find_by_name_and_user_id( new_book_name, current_user.id)
	if aready_book
	  session[:book_id] = aready_book.id
	else
	  new_book = Book.new({ name: new_book_name})
	  new_book.user = current_user
	  new_book.save

	  session[:book_id] = new_book.id
	end
	render_current_book( filter_str )
  end

  def show
	session[:book_id] = params[:id]
	filter_str = params[:filter]
	render_current_book( filter_str )
  end

  def destroy
	filter_str = params[:filter]

	if current_book != nil
	  remove_book_name = current_book.name
	  remove_book_id = current_book.id

	  current_book.tasks.destroy_all
	  current_book.destroy
	  session[:book_id] = 0
	else
	  session[:book_id] = 0
	end
	render_current_book( filter_str )
  end

  private
  def render_current_book(filter_str = "")
	render_json_for_updateBookJson(filter_str, 15)
  end
*/
