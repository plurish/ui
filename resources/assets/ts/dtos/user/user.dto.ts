import { Role } from './role.dto';
import { UserPartial } from './user-partial.dto';

export class User extends UserPartial {
    public constructor(
        public readonly id: number,
        public readonly username: string,
        public readonly email: string,
        public readonly active: boolean,
        public readonly roles: Role[],
    ) {
        super(id, username, email, roles);
    }
}
