class TimeManager {
    constructor(task, recording_button, progressBar) {
        this.progressBar = progressBar;
        this.recording_button = recording_button;
        this.task = task;

        this.timer = null;
        this.secondsone = 0;
        this.secondstwo = null;
        this.hours = 0;
        this.minutes = 0;
    }

    startTimer() {
        this.timer = setInterval(() => {
            this.updateTimer();
        }, 1000);
    }

    stopTimer() {
        clearInterval(this.timer);
        console.log('timer off');
    }

    resetTimer() {
        console.log('timer reset');
        clearInterval(this.timer);
        if (this.task === 1) {
            this.seconds1 = 0;
            this.progressBar.style.width = '0%'; // Assuming progressBar is a valid element
        } else if (this.task === 2) {
            this.secondstwo = 35;
        }
        this.minutes = 0;
        this.hours = 0;
        this.updateTimerDisplay();
    }

    updateTimer() {
        if (this.task === 2) {
            this.secondstwo--;
            if (this.secondstwo === 30) {
                clearInterval(this.timer);
                this.recording_button.click();
            }
        } else if (this.task === 1) {
            // this is progress increasing
            var currentWidth = parseFloat(this.progressBar.style.width) || 0;
            var newWidth = (currentWidth + 2.5) % 101;
            this.progressBar.style.width = newWidth + '%';

            this.seconds1++;
            if (this.seconds1 === 40) {
                clearInterval(this.timer);
                this.recording_button.click();
            }
        } else if (this.task === 3) {
            this.seconds1++;
            if (this.seconds1 === 60) {
                this.seconds1 = 0;
                this.minutes++;
                if (this.minutes === 60) {
                    this.minutes = 0;
                    this.hours++;
                }
            }
        }
        this.updateTimerDisplay();
    }

    updateTimerDisplay() {
        if (this.task === 1) {
            const formattedTime = `${this.pad(this.hours)}:${this.pad(this.minutes)}:${this.pad(this.seconds1)}`;
            $("#timer").text(formattedTime);
        } else if (this.task === 2) {
            const formattedTime = `${this.pad(this.hours)}:${this.pad(this.minutes)}:${this.pad(this.secondstwo)}`;
            $("#prepair-timer").text(formattedTime);
        }
    }

    pad(value) {
        return value < 10 ? `0${value}` : value;
    }
}
