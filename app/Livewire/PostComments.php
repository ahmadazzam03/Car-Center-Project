<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class PostComments extends Component
{
    public $car; 
    public $comment; 
    protected $rules = [
        'comment' => 'required|string|max:1000',
    ];

    public function mount(Car $car)
    {
        $this->car = $car;
    }
    public function addComment()
    {
        if(auth()->guest())
        {
            return;
        }
        $this->validate();

        Comment::create([
            'user_id' => auth()->id(),
            'car_id' => $this->car->id,
            'comment' => $this->comment,
        ]);

        // إعادة تعيين الحقل
        $this->reset('comment');

        // إعادة تحميل التعليقات
        $this->car->refresh();
    }

    public function render()
    {
        return view('livewire.post-comments', 
        [
            'comments' => $this->car->comments()
            ->with('user')->latest()
            ->paginate(3),
        ]);
    }
    
}
