<?php

namespace App\Livewire\Operations;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ExpenseManager extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $monthFilter;
    public $showModal = false;
    public $expenseId;

    // Form fields
    public $category;
    public $amount;
    public $description;
    public $date;

    protected $rules = [
        'category' => 'required|string',
        'amount' => 'required|numeric|min:0',
        'description' => 'nullable|string|max:500',
        'date' => 'required|date',
    ];

    public function mount()
    {
        $this->monthFilter = now()->format('Y-m');
        $this->date = now()->format('Y-m-d');
    }

    public function render()
    {
        $query = Expense::with('user')
            ->orderBy('date', 'desc');

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        if ($this->monthFilter) {
            $query->where('date', 'like', $this->monthFilter . '%');
        }

        $expenses = $query->paginate(15);
        $totalAmount = $query->sum('amount');

        return view('livewire.operations.expense-manager', [
            'expenses' => $expenses,
            'totalAmount' => $totalAmount
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['category', 'amount', 'description', 'expenseId']);
        $this->date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $this->expenseId = $expense->id;
        $this->category = $expense->category;
        $this->amount = $expense->amount;
        $this->description = $expense->description;
        $this->date = $expense->date->format('Y-m-d');

        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'category' => $this->category,
            'amount' => $this->amount,
            'description' => $this->description,
            'date' => $this->date,
            'incurred_by' => auth()->id()
        ];

        if ($this->expenseId) {
            $expense = Expense::findOrFail($this->expenseId);
            $expense->update($data);
            session()->flash('message', 'Expense updated successfully.');
        } else {
            Expense::create($data);
            session()->flash('message', 'Expense added successfully.');
        }

        $this->showModal = false;
    }

    public function delete($id)
    {
        Expense::findOrFail($id)->delete();
        session()->flash('message', 'Expense deleted successfully.');
    }
}
