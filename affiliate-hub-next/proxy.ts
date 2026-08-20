import { NextResponse, type NextRequest } from "next/server";

function unauthorized() {
  return new NextResponse("Authentication required", {
    status: 401,
    headers: {
      "WWW-Authenticate": 'Basic realm="Owner Dashboard", charset="UTF-8"',
    },
  });
}

function readBasicCredentials(header: string | null): { username: string; password: string } | null {
  if (!header?.startsWith("Basic ")) return null;

  try {
    const decoded = atob(header.slice(6));
    const separator = decoded.indexOf(":");
    if (separator === -1) return null;

    return {
      username: decoded.slice(0, separator),
      password: decoded.slice(separator + 1),
    };
  } catch {
    return null;
  }
}

export function proxy(request: NextRequest) {
  const ownerUser = process.env.OWNER_DASHBOARD_USER || "owner";
  const ownerPassword = process.env.OWNER_DASHBOARD_PASSWORD;

  if (!ownerPassword) {
    return new NextResponse("Owner dashboard password is not configured", { status: 503 });
  }

  const credentials = readBasicCredentials(request.headers.get("authorization"));

  if (credentials?.username === ownerUser && credentials.password === ownerPassword) {
    return NextResponse.next();
  }

  return unauthorized();
}

export const config = {
  matcher: ["/insights/:path*"],
};
