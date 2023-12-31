import { Role } from './role.dto';

export class UserPartial {
    public constructor(
        public readonly id: number,
        public readonly username: string,
        public readonly email: string,
        public readonly roles: Role[],
    ) {}
}
