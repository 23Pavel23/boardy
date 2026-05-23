from fastapi import APIRouter, Depends, HTTPException
from pydantic import BaseModel, Field
from typing import List, Dict, Any
import aiomysql
from database import get_db
from auth import get_current_user
from routers.ws import manager

router = APIRouter(prefix="/api", tags=["comments"])

class CommentIn(BaseModel):
    body: str = Field(..., min_length=1, max_length=2000)
    author_name: str = Field(..., min_length=1, max_length=255)

class CommentUpdate(BaseModel):
    body: str = Field(..., min_length=1, max_length=2000)

async def db_query(sql: str, *args) -> List[Dict[str, Any]]:
    conn = await get_db()
    async with conn.cursor(aiomysql.DictCursor) as cur:
        await cur.execute(sql, args)
        result = await cur.fetchall()
    conn.close()
    return result

async def db_query_one(sql: str, *args) -> Dict[str, Any]:
    conn = await get_db()
    async with conn.cursor(aiomysql.DictCursor) as cur:
        await cur.execute(sql, args)
        result = await cur.fetchone()
    conn.close()
    return result

async def db_execute(sql: str, *args) -> int:
    conn = await get_db()
    async with conn.cursor() as cur:
        await cur.execute(sql, args)
        await conn.commit()
        last_id = cur.lastrowid
    conn.close()
    return last_id

@router.get("/posts/{post_id}/comments")
async def list_comments(post_id: int):
    rows = await db_query(
        "SELECT * FROM comments WHERE post_id=%s ORDER BY created_at",
        post_id
    )
    return {"items": rows, "count": len(rows)}

@router.post("/posts/{post_id}/comments", status_code=201)
async def create_comment(post_id: int, data: CommentIn, user=Depends(get_current_user)):
    comment_id = await db_execute(
        "INSERT INTO comments (post_id, author_id, author_name, body) VALUES (%s, %s, %s, %s)",
        post_id, user["sub"], data.author_name, data.body
    )
    comment = {
        "id": comment_id,
        "post_id": post_id,
        "author_id": user["sub"],
        "author_name": data.author_name,
        "body": data.body,
        "created_at": None
    }
    await manager.broadcast({"type": "new_comment", "comment": comment})
    return comment

@router.put("/comments/{comment_id}")
async def update_comment(comment_id: int, data: CommentUpdate, user=Depends(get_current_user)):
    existing = await db_query_one("SELECT * FROM comments WHERE id=%s", comment_id)
    if not existing:
        raise HTTPException(status_code=404, detail="Not found")
    
    # Приводим оба значения к int для корректного сравнения
    if int(existing["author_id"]) != int(user["sub"]):
        raise HTTPException(status_code=403, detail="Not your comment")

    await db_execute("UPDATE comments SET body=%s WHERE id=%s", data.body, comment_id)
    await manager.broadcast({
        "type": "update_comment",
        "comment": {"id": comment_id, "body": data.body}
    })
    return {"id": comment_id, "body": data.body}

@router.delete("/comments/{comment_id}", status_code=204)
async def delete_comment(comment_id: int, user=Depends(get_current_user)):
    existing = await db_query_one("SELECT * FROM comments WHERE id=%s", comment_id)
    if not existing:
        raise HTTPException(status_code=404, detail="Not found")
    
    # Приводим оба значения к int для корректного сравнения
    if int(existing["author_id"]) != int(user["sub"]):
        raise HTTPException(status_code=403, detail="Not your comment")

    await db_execute("DELETE FROM comments WHERE id=%s", comment_id)
    await manager.broadcast({
        "type": "delete_comment",
        "comment_id": comment_id
    })
    return {"ok": True}
