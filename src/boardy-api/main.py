from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from contextlib import asynccontextmanager
import asyncio
import aioredis
import json
from datetime import datetime
from routers import comments, ws
from database import get_db

async def db_execute(sql: str, *args):
    conn = await get_db()
    async with conn.cursor() as cur:
        await cur.execute(sql, args)
        await conn.commit()
    conn.close()

async def redis_subscriber():
    redis = await aioredis.from_url('redis://127.0.0.1:6379')
    pubsub = redis.pubsub()
    await pubsub.subscribe('new_post', 'user.renamed')
    
    async for message in pubsub.listen():
        if message['type'] != 'message':
            continue
        channel = message['channel'].decode()
        data = json.loads(message['data'])
        
        if channel == 'new_post':
            await ws.manager.broadcast({
                'type': 'new_post',
                'post': data
            })
        elif channel == 'user.renamed':
            await db_execute(
                'UPDATE comments SET author_name=%s WHERE author_id=%s',
                data['new_name'], data['id']
            )
            await ws.manager.broadcast({
                'type': 'user_renamed',
                'user_id': data['id'],
                'new_name': data['new_name']
            })

@asynccontextmanager
async def lifespan(app: FastAPI):
    task = asyncio.create_task(redis_subscriber())
    yield
    task.cancel()

app = FastAPI(title='Boardy API', version='0.5.0', lifespan=lifespan)

app.add_middleware(
    CORSMiddleware,
    allow_origins=['https://pablo52.ai-info.ru'],
    allow_credentials=True,
    allow_methods=['*'],
    allow_headers=['*'],
)

app.include_router(comments.router)
app.include_router(ws.router)

@app.get('/api/status')
async def status():
    return {'status': 'ok', 'time': str(datetime.now())}

@app.get("/health")
def health():
    return {"ok": True}

@app.get("/api/health")
def api_health():
    return {"ok": True}
