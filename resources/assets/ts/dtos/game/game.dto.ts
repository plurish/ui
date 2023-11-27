import { GamePartial } from './game-partial.dto';

export type Game = GamePartial & {
    game_url: string;
    release_date: Date;
    sys_requirements: null | {
        os: string;
        processor: string;
        memory: string;
        graphics: string;
        storage: string;
    };
    screenshots: string[];
};
