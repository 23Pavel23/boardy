from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from routers import comments

app = FastAPI(title='Boardy API', version='0.1.0')

# Разрешаем CORS для всех источников (для разработки)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(comments.router)

@app.get('/api/status')
async def status():
    return {'status': 'ok'}
