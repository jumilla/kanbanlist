<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;

class Task extends Eloquent
{
	public static $status_table = [
		'todo_h' => 1,
		'todo_m' => 2,
		'todo_l' => 3,
		'doing' => 4,
		'waiting' => 5,
		'done' => 6,
	];

	public function statusSymbol()
	{
		return array_search($this->status, static::$status_table);
	}

	protected $guarded = ['id'];

	public function user()
	{
		return $this->hasOne('User');
	}

	public function book()
	{
		return $this->hasOne('Book');
	}

	public function bookName()
	{
		if ($this->book_id){
			return $this->book->name;
		}
		return '';
	}

	public function messageWithoutBookName()
	{
		if (!$this->book_id) {
			return $this->message;
		}

		$message = $this->message;
		foreach (Book::$book_name_patterns as $book_name_pattern) {
			$message = preg_replace($book_name_pattern, '', $this->message);
		}
		return $message;
	}

	public function isDone()
	{
		return $this->status == static::$status_table['done'];
	}

	public function scopeByNameAndStatus($query, $name, $status)
	{
		return $query
			->where('name', $name)
			->where('status', static::$status_table[$status])
		;
	}

	public function scopeByStatus($query, $status)
	{
		return $query
			->where('status', static::$status_table[$status])
			->orderBy('order_no', 'ASC')
			->orderBy('updated_at', 'DESC')
		;
	}

	public function scopeByStatusAndFilter($query, $status, $filter)
	{
		return $query
			->where('status', static::$status_table[$status])
			->where('message', 'like', "%$filter%")
			->orderBy('order_no', 'ASC')
			->orderBy('updated_at', 'DESC')
		;
	}

	public function scopeFiltered($query, $name, $filter)
	{
		return $query
			->where('name', $name)
			->where('message', 'like', "%$filter%")
			->orderByOrderNo()
			->orderByUpdatedAt('DESC')
		;
	}

	public function scopeDone($query, $order = 'DESC')
	{
		return $query
			->where('status', static::$status_table['done'])
			->orderBy('updated_at', $order)
		;
	}

	public function scopeDoneAndFilter($query, $filter)
	{
		return $query
			->where('status', static::$status_table['done'])
			->where('message', 'like', "%$filter%")
			->orderBy('updated_at', 'DESC')
		;
	}

	public function scopeTodayTouch($query)
	{
		return $query->where('status', '!=', static::$status_table['done'])
			->where('updated_at', '>=', Carbon::today())
			->where('updated_at', '<=', Carbon::now())
			->orderBy('updated_at', 'DESC');
	}

	public function scopeTodayDone($query)
	{
		return $query
			->where('status', static::$status_table['done'])
			->where('updated_at', 'like', Carbon::today()->format('Y-m-d'))
			->orderBy('updated_at', 'DESC');
		;
	}

	public function scopeSelectMonth($query, $month)
	{
		return $query
			->where('updated_at', '>=', $month)
			->where('updated_at', '<' , Carbon::instance($month)->addMonth())
		;
	}

	public function scopeNewestAdd($query)
	{
		return $query
			->where('status', '!=', static::$status_table['done'])
			->orderBy('created_at', 'desc')->take(10);
	}

	public function scopeNewestDone($query)
	{
		return $query
			->where('status', '=', static::$status_table['done'])
			->orderBy('updated_at', 'desc')->take(10);
		;
	}

	public function scopeOldestUpdate($query)
	{
		return $query
			->where('status', '!=', static::$status_table['done'])
			->orderBy('updated_at', 'asc')->take(10);
	}

	public static function countsByStatus(Relation $relation)
	{
		$counts = [];
		foreach (array_keys(Task::$status_table) as $status_name) {
			$counts[$status_name] = 0;
		}
		foreach ($relation->select('status', DB::raw('count(*) as total'))->groupBy('status')->get() as $result) {
			$status_name = array_search($result->status, Task::$status_table);
			$counts[$status_name] = (int)$result->total;
		}
		return $counts;
	}

	public static function doneMonthList(Relation $relation)
	{
		$fromMonth = Carbon::now()->firstOfMonth()->subYear();
		$toMonth = static::toDoneMonth();

		$monthList = [];
		while ($toMonth > $fromMonth) {
			$monthList[] = [
				'date' => clone $toMonth,
				'count' => static::done()->selectMonth($toMonth)->count(),
			];
			$toMonth = $toMonth->subMonth();
		}
		return $monthList;
	}

	public static function fromDoneMonth()
	{
		$oldestDoneTask = Task::done('ASC')->first();
		if (!$oldestDoneTask) {
			return Carbon::now()->firstOfMonth();
		}
		else {
			$loldestDoneAt = $oldestDoneTask->updated_at;
			return $latestDoneAt->firstOfMonth();
		}
	}

	public static function toDoneMonth()
	{
		$latestDoneTask = Task::done('DESC')->first();
		if (!$latestDoneTask) {
			return Carbon::now()->firstOfMonth();
		}
		else {
			$latestDoneAt = $latestDoneTask->updated_at;
			return $latestDoneAt->firstOfMonth();
		}
	}

	public static function todayCount()
	{
		return static::where('created_at', '>=', Carbon::today())->where('created_at', '<=', Carbon::now())->count();
	}

	public static function csv($options = [])
	{
//
//    csv_data = CSV.generate(options) do |csv|
//csv << ["Book", "Task", "Status", "UpdatedAt"]
//[:doing,:todo_h,:todo_m, :todo_l, :waiting].each do |st|
//self.by_status(st).each do |t|
//csv << [t.book_name, t.message_without_book_name, t.statusSymbol(), t.updated_at]
//        }
//      }
//      self.done.each do |t|
//csv << [t.book_name, t.message_without_book_name, t.statusSymbol(), t.updated_at]
//    }
//    #SJISに変換するかどうか悩む
//      #csv_data.encode(Encoding::SJIS)
	}

}
