<?php
class Calendar {

    private $currentYear, $currentMonth, $currentDay;
    private $timeSlots = [];

    public function __construct($date = null) {
        $this->currentYear = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->currentMonth = $date != null ? date('m', strtotime($date)) : date('m');
        $this->currentDay = $date != null ? date('d', strtotime($date)) : date('d');
       
    }

    public function __toString() {
        $numDays = date('t', strtotime($this->currentDay . '-' . $this->currentMonth . '-' . $this->currentYear));
        $lastMonthNumOfDays = date('j', strtotime('last day of previous month', strtotime($this->currentDay . '-' . $this->currentMonth . '-' . $this->currentYear)));
        $daysOfWeek = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
        $startDay = array_search(date('l', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')), $daysOfWeek);
        $calendarBuilder = '<div class="calendar col-lg-7" style="display:inline-block">';
        $calendarBuilder .= '<div class="header" id=month'.$this->currentMonth.'>';
        $calendarBuilder .= '<div class="month-year">';
        $calendarBuilder .= date('F Y', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . $this->currentDay));
        $calendarBuilder .= '</div>';
        $calendarBuilder .= '</div>';
        $calendarBuilder .= '<div class="days">';
        foreach ($daysOfWeek as $day) {
            $calendarBuilder .= '
                <div class="dayName">
                    ' . $day . '
                </div>
            ';
        }
        for ($i = $startDay; $i > 0; $i--) {
            $calendarBuilder .= '
                <div class="dayNum ignore">
                    ' . ($lastMonthNumOfDays-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $numDays; $i++) {
            $selected = '';
            if ($i == $this->currentDay) {
                $selected = ' selected';
            }
            $calendarBuilder .= '<div class="dayNum' . $selected . '">';
            $calendarBuilder .= '<span class="dateNum" id='.$i.$this->currentMonth.$this->currentYear.'>' . $i . '</span>';
            foreach ($this->timeSlots as $timeSlot) {
                for ($d = 0; $d <= ($timeSlot[3]-1); $d++) {
                    if (date('y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($timeSlot[2]))) {
                        $calendarBuilder .= '<div id='.$timeSlot[0].' class="timeSlot' . $timeSlot[4] . '">';
                        $calendarBuilder .= $timeSlot[1];
                        $calendarBuilder .= '</div>';
                    }
                }
            }
            $calendarBuilder .= '</div>';
        }
        for ($i = 1; $i <= (42-$numDays-max($startDay, 0)); $i++) {
            $calendarBuilder .= '
                <div class="dayNum ignore">
                    ' . $i . '
                </div>
            ';
        }
        $calendarBuilder .= '</div>';
        $calendarBuilder .= '</div>';
        return $calendarBuilder;
    }
   
    public function addTimeSlot($id, $txt, $date, $daysOfWeek = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->timeSlots[] = [$id, $txt, $date, $daysOfWeek, $color];
    }

}
?>