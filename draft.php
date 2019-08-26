<?php
require __DIR__ . '/vendor/autoload.php';

class TicTacToe
{
    // BEGIN (write your solution here)
    private $strategy;
    private $field = [ 
        'row1' => [ 'col1' => null, 'col2' => null, 'col3' => null ],
        'row2' => [ 'col1' => null, 'col2' => null, 'col3' => null ],
        'row3' => [ 'col1' => null, 'col2' => null, 'col3' => null ]
    ];
    private $victoryConditions;

    public function __construct($strategy = 'Easy')
    {
        $this->strategy = $strategy;
    }
    public function go($row = null, $col = null)
    {
        if ($row && $col) {
            $this->field["row{$row}"]["col{$col}"] = 'dagger';
        } else {
            $ai = new $this->strategy($this->field);
            $this->field = $ai->go();
        }
        $this->refresh();

        foreach ($this->victoryConditions as $row) {
            $firstElem = $row['col1'];
            $isWinner = collect($row)->every(function($value) use($firstElem) {
                return $value !== null && $value === $firstElem;
            });
            if ($isWinner) return true;
        }
        return false;
    }
    public function refresh()
    {
        $this->victoryConditions = [
            'horizontal1' => $this->field['row1'],
            'horizontal2' => $this->field['row2'],
            'horizontal3' => $this->field['row3'],
            'vertical1' => [ 
                'col1' => $this->field['row1']['col1'],
                'cell2' => $this->field['row2']['col1'],
                'cell3' => $this->field['row3']['col1']
            ],
            'vertical2' => [ 
                'col1' => $this->field['row1']['col2'],
                'cell2' => $this->field['row2']['col2'],
                'cell3' => $this->field['row3']['col2']
            ],
            'vertical3' => [ 
                'col1' => $this->field['row1']['col3'],
                'cell2' => $this->field['row2']['col3'],
                'cell3' => $this->field['row3']['col3']
            ],
            'diagonal1' => [ 
                'col1' => $this->field['row1']['col1'],
                'cell2' => $this->field['row2']['col2'],
                'cell3' => $this->field['row3']['col3']
            ],
            'diagonal2' => [ 
                'col1' => $this->field['row1']['col3'],
                'cell2' => $this->field['row2']['col2'],
                'cell3' => $this->field['row3']['col1']
            ],
        ];
    }
    // END
}

class Easy
{
    // BEGIN (write your solution here)
    private $field;

    public function __construct($field)
    {
        $this->field = $field;
    }
    public function go()
    {
        foreach ($this->field as $rowNumber => $row) {
            foreach ($row as $colNumber => $value) {
                if (!$row[$colNumber]) {
                    $this->field[$rowNumber][$colNumber] = 'zero';
                    return $this->field;
                }
            }
        }
        return 'field is full';
    }
    // END
}

class Normal
{
    // BEGIN (write your solution here)
    private $field;

    public function __construct($field)
    {
        $this->field = $field;
    }
    public function go()
    {
        $reversedField = array_reverse($this->field);
        foreach ($reversedField as $rowNumber => $row) {
            foreach ($row as $colNumber => $value) {
                if (!$row[$colNumber]) {
                    $reversedField[$rowNumber][$colNumber] = 'zero';
                    return array_reverse($reversedField);
                }
            }
        }
        return 'field is full';
    }
    // END
}

$game = new TicTacToe();
$game->go(2, 2);
$game->go();
$game->go(2, 3);
var_dump($game->go());
var_dump($game->go(3, 3));
var_dump($game->go());


