from fastapi import FastAPI, Request
from datetime import datetime
import aiomysql
from routers import comments, ws
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI(title='Boardy API', version='0.3.0')

app.add_middleware(
    CORSMiddleware,
    allow_origins=['*'],
    allow_credentials=True,
    allow_methods=['*'],
    allow_headers=['*'],
)

app.include_router(comments.router)
app.include_router(ws.router)

@app.post('/internal/broadcast')
async def internal_broadcast(request: Request):
    data = await request.json()
    await ws.manager.broadcast({'type': 'new_post', 'post': data})
    return {'ok': True}

DB_CONFIG = {
    'host': 'localhost',
    'port': 3306,
    'user': 'pablo52',
    'password': 'Piano@123',
    'db': 'boardy_main',
    'charset': 'utf8mb4'
}

async def get_db():
    return await aiomysql.connect(**DB_CONFIG)

@app.get('/api/status')
async def status():
    return {'status': 'ok', 'time': str(datetime.now())}
