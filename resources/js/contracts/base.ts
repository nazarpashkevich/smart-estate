export interface BaseData<T> {
    data: T[],
    meta: {
        from: number,
        to: number,
        current_page: number,
        per_page: number,
        total: number,
    }
}
