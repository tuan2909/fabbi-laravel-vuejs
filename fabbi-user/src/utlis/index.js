
function getTotalTime(dateStart, dateEnd) {
    const _MS_PER_DAY = 1000 * 60 * 60 * 24;
    let time_start = new Date(dateStart);
    let time_end = new Date(dateEnd);
    // Discard the time and time-zone information.
    const utc1 = Date.UTC(time_start.getFullYear(), time_start.getMonth(), time_start.getDate());
    const utc2 = Date.UTC(time_end.getFullYear(), time_end.getMonth(), time_end.getDate());

    return Math.floor((utc2 - utc1) / _MS_PER_DAY);
}

export {
    getTotalTime,
}