export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    can: {
        [key: string]: boolean;
    };
    auth: {
        user: User;
    };
};
