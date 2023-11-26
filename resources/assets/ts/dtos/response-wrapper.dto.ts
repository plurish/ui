export class ResponseWrapper<T> {
    public constructor(
        public readonly data: T,
        public readonly message: string,
        public readonly status: number,
    ) {}
}