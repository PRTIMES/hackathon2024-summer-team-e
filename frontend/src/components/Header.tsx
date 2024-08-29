import ArrowBackIcon from '@mui/icons-material/ArrowBack'
import ArrowForwardIcon from '@mui/icons-material/ArrowForward' // 進むボタン用のアイコンをインポート
import { AppBar, Box, Container, IconButton } from '@mui/material'
import { useRouter } from 'next/router'

const Header = () => {
  const router = useRouter()

  // ブラウザの進む機能を実装
  const goForward = () => {
    if (typeof window !== 'undefined') {
      window.history.forward()
    }
  }

  return (
    <AppBar
      position="static"
      sx={{
        backgroundColor: '#84a2d4', // 背景色を青に変更
        color: 'white', // テキスト色を白に変更
        boxShadow: 'none',
        py: '12px',
      }}
    >
      <Container maxWidth="lg" sx={{ px: 2 }}>
        <Box
          sx={{
            display: 'flex',
            justifyContent: 'space-between', // コンテンツを両端に配置
            alignItems: 'center',
            width: '100%', // Boxの幅を100%に設定
          }}
        >
          <IconButton onClick={() => router.back()} sx={{ color: 'white' }}>
            <ArrowBackIcon />
          </IconButton>
          <h1 style={{ flexGrow: 1, textAlign: 'center' }}>サーチポート</h1>
          <IconButton onClick={goForward} sx={{ color: 'white' }}>
            <ArrowForwardIcon />
          </IconButton>
        </Box>
      </Container>
    </AppBar>
  )
}

export default Header
