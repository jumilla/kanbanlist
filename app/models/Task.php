<?php

use Carbon\Carbon;

class Task extends Eloquent
{
	public static $status_table = [
		'todo_h' => 0,
		'todo_m' => 1,
		'todo_l' => 2,
		'doing' => 3,
		'waiting' => 4,
		'done' => 5,
	];

	protected $guarded = ['id'];

	public function user()
	{
		$this->hasOne('User');
	}

	public function book()
	{
		$this->hasOne('Book');
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
			->whereLike('msg', 'like', "%#%")//todo
			->orderBy('order_no', 'ASC')
			->orderBy('updated_at', 'DESC')
		;
		//where("status = ? and msg LIKE ?", @@status_table[status] , "%#{URI.decode(filter)}%").order('order_no ASC, updated_at DESC')
	}

	public function scopeFiltered($query, $name, $filter)
	{
		return $query
		//where("name = ? and msg LIKE ?", name ,"%#{URI.encode(filter)}%").order('order_no ASC, updated_at DESC')
		;
	}

	public function scopeDone($query)
	{
		return $query
			->where('status', static::$status_table['done'])
			->orderBy('updated_at', 'DESC')
		;
	}

	public function scopeDoneAndFilter($query, $filter)
	{
		return $query
		//where("status = ? and msg LIKE ?", @@status_table[:done] , "%#{URI.decode(filter)}%").order('updated_at DESC')
		;
	}

	public function scopeTodayDone($query)
	{
		return $query
		//where("status = ? and updated_at LIKE ?", @@status_table[:done], "#{Time.now.strftime("%Y-%m-%d")}%").order('updated_at DESC' )
		;
	}

	public function scopeSelectMonth($query)
	{
		return $query
		//$select_mon;
//        where(" updated_at >= ? and updated_at < ? ", select_mon, select_mon + 1.month )
		;
	}

	public function scopeNewestAdd($query)
	{
		return $query
//        where("status != ?", @@status_table[:done]).order('created_at DESC' ).limit(10);
		;
	}

	public function scopeNewestDone($query)
	{
		return $query
//        where("status = ?", @@status_table[:done]).order('updated_at DESC' ).limit(10);
		;
	}

	public function scopeOldestUpdate($query)
	{
		return $query
//        where("status != ?", @@status_table[:done]).order('updated_at ASC' ).limit(10);
		;
	}

	public static function doneMonthList()
	{
//    from_month = Time.now - 1.year
//    to_month   = self.to_done_month
//
//    month_list = []
//    while from_month <= to_month do
//    month_list << { date: to_month, count: self.done.select_month(to_month).count}
//      to_month -= 1.month
//    }
//    return month_list
	}

	public static function fromDoneMonth()
	{
//    last_task = self.done.last
//    if last_task
//    from_time = last_task.updated_at
//      Time.new(from_time.year, from_time.mon)
//    else
//      Time.now
//    }
	}

	public static function toDoneMonth()
	{
//    first_task = self.done.first
//    if first_task
//    to_time = first_task.updated_at
//      Time.new(to_time.year, to_time.mon)
//    else
//      Time.now
//    }
	}

	public static function todayCount()
	{
		return static::where('created_at', '>=', Carbon::today())->where('created_at', '<=', Carbon::now())->count();
	}

	public static function todayTouch()
	{
//    self.where('status != ? and updated_at >= ? and updated_at <= ?', @@status_table[:done], 1.day.ago, Time.now).order("updated_at DESC")
	}

	public static function csv($options = [])
	{
//
//    csv_data = CSV.generate(options) do |csv|
//csv << ["Book", "Task", "Status", "UpdatedAt"]
//[:doing,:todo_h,:todo_m, :todo_l, :waiting].each do |st|
//self.by_status(st).each do |t|
//csv << [t.book_name, t.msg_without_book_name, t.status_sym, t.updated_at]
//        }
//      }
//      self.done.each do |t|
//csv << [t.book_name, t.msg_without_book_name, t.status_sym, t.updated_at]
//    }
//    #SJISに変換するかどうか悩む
//      #csv_data.encode(Encoding::SJIS)
	}

	public function statusSymbol()
	{
		return array_search($this->status, static::$status_table);
	}

	public function bookName()
	{
		if ($this->book_id){
			return $this->book->name;
		}
		return '';
	}

	public function msgWithoutBookName()
	{
		if (!$this->book_id) {
			return $this->msg;
		}

		$msg = $this->msg;
		foreach (Book::$book_name_patterns as $book_name_pattern) {
			$msg = preg_replace($book_name_pattern, '', $this->msg);
		}
		return $msg;
	}

}
