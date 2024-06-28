export interface PaginationMeta {
    from: number,
    to: number,
    current_page: number,
    last_page: number,
    per_page: number,
    total: number,
    path: string,
    pageName: string,
}

export interface BaseData<T> {
    data: T[],
    meta: PaginationMeta
}
