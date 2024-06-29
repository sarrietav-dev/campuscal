import axios from "axios";

const url = "/api";

export type Campus = { id: number; name: string; images: { path: string }[] };

export async function getCampuses(): Promise<Campus[]> {
    const response = await axios.get<Campus[]>(`${url}/campuses`);
    return response.data;
}

export type Space = {
    id: number;
    name: string;
    campus_id: number;
    capacity: number;
    images: { path: string }[];
    resources: string[];
};

export async function getSpaces(
    campusId: number,
    images: "all" | "one" = "all",
): Promise<Space[]> {
    const response = await axios.get<Space[]>(`${url}/campuses/${campusId}`, {
        params: { images },
    });
    return response.data;
}

export async function getSpace(spaceId: number): Promise<Space> {
    const response = await axios.get<Space>(`${url}/spaces/${spaceId}`);
    return response.data;
}
